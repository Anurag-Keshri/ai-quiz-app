'use server';

import { z } from 'zod';
import { config } from '@/config';

export async function quizFormAction(formData: FormData) {
	const rawFormData = Object.fromEntries(formData);
	
	const formDataSchema = z.object({
		// model: z.string(),
		questions: z.coerce.number().min(1).max(50),
		options: z.coerce.number().min(2).max(10),
		difficulty: z.enum(['easy', 'medium', 'hard']),
		depth: z.enum(['shallow', 'medium', 'deep']),
		topic: z.string().min(1),
	});

	const validatedFields = formDataSchema.safeParse(rawFormData);

	if (!validatedFields.success) {
		console.error(validatedFields.error.flatten().fieldErrors);
		return;
	}


	const {/* model, */ questions, options, difficulty, depth, topic} = validatedFields.data;

	const requestBody = {
		numQuestions: questions,
		numOptions: options,
		difficulty,
		depth,
		topic,
	};

	const response = await fetch(config.api.baseURL + config.api.generateQuestions, {
		method: 'POST',
		headers: config.api.headers,
		body: JSON.stringify(requestBody),
	});

	if (!response.ok) {
		console.error(response.statusText);
		return;
	}

	const data = await response.json();
	console.log(data);
	return data;
}
