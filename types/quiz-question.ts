export interface QuizQuestion {
  question: string;
	options: { [key: number]: string };
  correctAnswer: number; 
}

