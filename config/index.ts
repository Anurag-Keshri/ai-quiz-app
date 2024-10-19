export const config = {
	api: {
		baseURL: 'http://localhost:3001/api',
		ping: '/quiz/ping',
		generateQuestions: '/quiz/generateQuestions',
		headers: {
			'Content-Type': 'application/json',
			'x-api-key': 'INTERNAL_API_KEY',
		},
	}
};