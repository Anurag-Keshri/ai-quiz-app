'use server';

export async function quizFormAction(formData: FormData) {
	console.log(formData);
	return formData;
}
