<div style="width: 400px; max-height: 120px; overflow: hidden; word-wrap: break-word; word-break: break-word;">
    <style>
        .markdown-table-content { 
            margin-top: 0.5rem !important;
            margin-left: 0.7rem !important;
            line-height: 1.6 !important;
            display: block !important;
            white-space: normal !important;
        }
        .markdown-table-content p { 
            margin-bottom: 0.5rem !important; 
            display: block !important;
            word-wrap: break-word !important;
        }
        .markdown-table-content ul { 
            list-style-type: disc !important; 
            padding-left: 1rem !important; 
            margin-bottom: 0.5rem !important; 
            display: block !important;
        }
        .markdown-table-content ol { 
            list-style-type: decimal !important; 
            padding-left: 1rem !important; 
            margin-bottom: 0.5rem !important; 
            display: block !important;
        }
        .markdown-table-content li { 
            display: list-item !important; 
            margin-bottom: 0.25rem !important; 
            word-wrap: break-word !important;
        }
        .markdown-table-content strong { font-weight: bold !important; }
        .markdown-table-content em { font-style: italic !important; }
        .markdown-table-content code { 
            background-color: #f3f4f6 !important; 
            padding: 0.125rem 0.25rem !important; 
            border-radius: 0.25rem !important; 
            font-size: 0.875rem !important;
        }
        .markdown-table-content h1, .markdown-table-content h2, .markdown-table-content h3 { 
            font-weight: 600 !important; 
            margin-bottom: 0.5rem !important;
            display: block !important;
        }
        .markdown-table-content pre {
            white-space: pre-wrap !important;
            overflow-x: auto !important;
            word-wrap: break-word !important;
        }
    </style>
    <div class="text-sm markdown-table-content">
        {!! \Illuminate\Support\Str::limit(\Illuminate\Support\Str::markdown($getState()), 300) !!}
    </div>
</div>