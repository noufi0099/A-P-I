<?php

header("Content-Type: application/json");

$google_api_key = "AIzaSyAiGUecmRp8HQHYmeJd5zux7sskeMa28Qs";
$search_engine_id = "6409f969bb3064a2a";
$openai_api_key = "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";

if (!isset($_GET['query'])) {
    echo json_encode(["error" => "Missing query parameter"]);
    exit;
}

$query = urlencode($_GET['query']);

// Step 1: Fetch search results from Google
$google_url = "https://www.googleapis.com/customsearch/v1?q=$query&key=$google_api_key&cx=$search_engine_id";
$google_response = file_get_contents($google_url);
$google_data = json_decode($google_response, true);

// Extract first search result
if (!isset($google_data["items"][0])) {
    echo json_encode(["error" => "No search results found"]);
    exit;
}

$first_result = $google_data["items"][0];
$title = $first_result["title"];
$link = $first_result["link"];
$snippet = $first_result["snippet"];

// Step 2: Summarize using ChatGPT
$openai_url = "https://api.openai.com/v1/chat/completions";

$chatgpt_prompt = "
Summarize the following article snippet in a structured format:

Title: $title
Snippet: $snippet

Provide a structured JSON output with the following fields:
{
    \"title\": \"\",
    \"summary\": \"\",
    \"keywords\": [],
    \"source\": \"\"
}";

$chatgpt_data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are an assistant that summarizes search results in JSON format."],
        ["role" => "user", "content" => $chatgpt_prompt]
    ]
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/json\r\n" .
                     "Authorization: Bearer $openai_api_key\r\n",
        "method"  => "POST",
        "content" => json_encode($chatgpt_data),
    ]
];

$context  = stream_context_create($options);
$chatgpt_response = file_get_contents($openai_url, false, $context);
$chatgpt_result = json_decode($chatgpt_response, true);

// Extract structured JSON from response
if (!isset($chatgpt_result["choices"][0]["message"]["content"])) {
    echo json_encode(["error" => "ChatGPT response error"]);
    exit;
}

$structured_output = json_decode($chatgpt_result["choices"][0]["message"]["content"], true);
$structured_output["source"] = $link; // Add source link

echo json_encode($structured_output);

?>
