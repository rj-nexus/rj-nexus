<?php

return [
    'providers' => [
        [
            'name' => 'groq',
            'key_name' => 'groq',
            'type' => 'openai',
            'url'  => 'https://api.groq.com/openai/v1/chat/completions',
            'model'=> 'openai/gpt-oss-20b',
        ],
        [
            'name' => 'pollinations',
            'key_name' => 'pollinations',
            'type' => 'openai',
            'url'  => 'https://text.pollinations.ai/openai',
            'model'=> 'openai',
        ],
        [
            'name' => 'mistral',
            'key_name' => 'mistral',
            'type' => 'openai',
            'url'  => 'https://api.mistral.ai/v1/chat/completions',
            'model'=> 'ministral-8b-latest',
        ],
        [
            'name' => 'gemini',
            'key_name' => 'gemini',
            'type' => 'gemini',
            'url'  => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.8-flash:generateContent',
            'model'=> 'gemini-3.8-flash',
        ],
        [
            'name' => 'nvidia',
            'key_name' => 'nvidia',
            'type' => 'openai',
            'url'  => 'https://integrate.api.nvidia.com/v1/chat/completions',
            'model'=> 'mistralai/mistral-large-4-1t-a52b',
        ],
        [
            'name' => 'huggingface',
            'key_name' => 'huggingface',
            'type' => 'openai',
            'url'  => 'https://router.huggingface.co/v1/chat/completions',
            'model'=> 'meta-llama/Llama-3.1-8B-Instruct',
        ],
        [
            'name' => 'llm7',
            'key_name' => 'llm7',
            'type' => 'openai',
            'url'  => 'https://api.llm7.io/v1/chat/completions',
            'model'=> 'mistral-large-3:675b',
        ],
        [
            'name' => 'cohere',
            'key_name' => 'cohere',
            'type' => 'cohere',
            'url'  => 'https://api.cohere.ai/v1/chat',
            'model'=> 'command-r-08-2024',
        ],
        [
            'name' => 'ovh',
            'key_name' => 'ovh',
            'type' => 'openai',
            'url'  => 'https://oai.endpoints.kepler.ai.cloud.ovh.net/v1/chat/completions',
            'model'=> 'Meta-Llama-3_3-70B-Instruct',
        ],
    ],
];
