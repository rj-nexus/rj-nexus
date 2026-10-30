<?php

return [
    'providers' => [
        [
            'name' => 'groq',
            'key_name' => 'groq',
            'type' => 'openai',
            'url'  => 'https://api.groq.com/openai/v1/chat/completions',
            'model'=> 'llama3-8b-8192', // Dəyişdirildi
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
            'model'=> 'ministral-8b-latest', // İşləyən model
        ],
        [
            'name' => 'gemini',
            'key_name' => 'gemini',
            'type' => 'gemini',
            'url'  => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent', // Dəyişdirildi
            'model'=> 'gemini-1.5-flash-latest',
        ],
        [
            'name' => 'nvidia',
            'key_name' => 'nvidia',
            'type' => 'openai',
            'url'  => 'https://integrate.api.nvidia.com/v1/chat/completions',
            'model'=> 'meta/llama-3.1-70b-instruct', // Model yeniləndi
        ],
        [
            'name' => 'huggingface',
            'key_name' => 'huggingface',
            'type' => 'openai',
            'url'  => 'https://router.huggingface.co/v1/chat/completions', // Yeni Router linki
            'model'=> 'meta-llama/Meta-Llama-3-8B-Instruct',
        ],
        [
            'name' => 'llm7',
            'key_name' => 'llm7',
            'type' => 'openai',
            'url'  => 'https://api.llm7.io/v1/chat/completions',
            'model'=> 'gpt-4o-mini', // Dəyişdirildi
        ],
        [
            'name' => 'cohere',
            'key_name' => 'cohere',
            'type' => 'cohere',
            'url'  => 'https://api.cohere.ai/v1/chat',
            'model'=> 'command-r-plus', // command-r silinib, bunu istifadə edirik
        ],
        [
            'name' => 'ovh',
            'key_name' => 'ovh',
            'type' => 'openai',
            'url'  => 'https://oai.endpoints.kepler.ai.cloud.ovh.net/v1/chat/completions',
            'model'=> 'Meta-Llama-3_3-70B-Instruct',
            // Qeyd: OVH açarı 403 verdi, yeni token lazımdır.
        ],
    ],
];
