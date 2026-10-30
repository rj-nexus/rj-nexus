<?php

return [
    'providers' => [
        [
            'name' => 'groq',
            'key_name' => 'groq',
            'type' => 'openai',
            'url'  => 'https://api.groq.com/openai/v1/chat/completions',
            'model'=> 'llama-3.1-8b-instant', // Dəyişdirildi (işlək model)
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
            'url'  => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', // Dəyişdirildi
            'model'=> 'gemini-2.0-flash',
        ],
        [
            'name' => 'nvidia',
            'key_name' => 'nvidia',
            'type' => 'openai',
            'url'  => 'https://integrate.api.nvidia.com/v1/chat/completions',
            'model'=> 'meta/llama-3.3-70b-instruct', // Dəyişdirildi
        ],
        [
            'name' => 'huggingface',
            'key_name' => 'huggingface',
            'type' => 'openai',
            'url'  => 'https://router.huggingface.co/v1/chat/completions', // Yeni router endpoint
            'model'=> 'meta-llama/Meta-Llama-3-8B-Instruct',
            // Qeyd: HF tokeninə "Inference Providers" icazəsi əlavə edilməlidir.
        ],
        [
            'name' => 'llm7',
            'key_name' => 'llm7',
            'type' => 'openai',
            'url'  => 'https://api.llm7.io/v1/chat/completions',
            'model'=> 'DeepSeek-V4-Flash-0731', // Dəyişdirildi (pulsuz model)
        ],
        [
            'name' => 'cohere',
            'key_name' => 'cohere',
            'type' => 'cohere',
            'url'  => 'https://api.cohere.ai/v1/chat',
            'model'=> 'command-r-08-2024', // Dəyişdirildi (işlək model)
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
