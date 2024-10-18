'use server';

import { z } from 'zod';

export async function quizFormAction(formData: FormData) {
	const data = Object.fromEntries(formData.entries());
	
	const schema = z.object({
		// model: z.string(),
		questions: z.coerce.number().min(1).max(50),
		options: z.coerce.number().min(2).max(10),
		difficulty: z.enum(['easy', 'medium', 'hard']),
		depth: z.enum(['shallow', 'medium', 'deep']),
		topic: z.string().min(1),
	});

	const validatedFields = schema.safeParse(data);

	if (!validatedFields.success) {
		console.error(validatedFields.error.flatten().fieldErrors);
		return;
	}

	return validatedFields.data;
}
