<div class="space-y-4">
    <!-- Question Text -->
    <div>
        <label for="question_text" class="block mb-1">Question Text</label>
        <textarea name="question_text" 
                  id="question_text" 
                  rows="3" 
                  class="w-full border rounded px-3 py-2 @error('question_text') border-red-500 @enderror"
                  required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
        @error('question_text')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Time Limit -->
    <div>
        <label for="time_limit" class="block mb-1">Time Limit (seconds)</label>
        <input type="number" 
               name="time_limit" 
               id="time_limit" 
               value="{{ old('time_limit', $question->time_limit ?? '') }}"
               class="w-full border rounded px-3 py-2 @error('time_limit') border-red-500 @enderror">
        @error('time_limit')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

	@php
		if (isset($question)) {
			$options = old('options', $question->options->pluck('option_text') ?? []);
			$correctOption = old('correct_option', $question->getCorrectOption()->option_text ?? '');
		} else {
			$options = old('options', []);
			$correctOption = old('correct_option', '');
		}
	@endphp

    <!-- Options -->
    <div x-data="{ options: {{ json_encode($options) }} }">
        <label class="block mb-1">Options</label>
        <div class="space-y-2">
            <template x-for="(option, index) in options" :key="index">
				<div class="flex items-center space-x-2">
                    <input type="text" 
                           :name="'options[' + index + ']'"
                           x-model="options[index]"
                           class="flex-1 border rounded px-3 py-2"
                           placeholder="Enter option"
                           required>
                    <input type="radio" 
                           name="correct_option" 
                           :value="index"
                           :checked="option === '{{ $correctOption }}'"
                           required>
                    <button type="button" 
                            @click="options = options.filter((_, i) => i !== index)"
                            class="text-red-500 hover:text-red-700"
                            x-show="options.length > 2">
                        Remove
                    </button>
                </div>
            </template>
        </div>
        
        <button type="button" 
                @click="options.push('')"
                class="mt-2 text-blue-500 hover:text-blue-700">
            + Add Option
        </button>

        @error('options')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
        @error('correct_option')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div> 