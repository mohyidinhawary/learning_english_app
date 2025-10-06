<div class="p-4">
    <h2 class="text-lg font-bold mb-2">معاينة التمرين</h2>

    <p><strong>السؤال:</strong> {{ $exercise['question'] ?? '-' }}</p>
    <p><strong>النوع:</strong> {{ $exercise['type'] ?? '-' }}</p>

    @if(!empty($exercise['options']))
        <p><strong>الخيارات:</strong></p>
        <ul>
            @foreach($exercise['options'] as $opt)
                <li>
                    {{ $opt['value'] ?? '' }}
                    @if(!empty($opt['is_correct']))
                        ✅
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
