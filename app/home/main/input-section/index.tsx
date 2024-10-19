"use client"

import Settings from "./settings";
import Prompt from "./topic";
import { Button } from "@/components/ui/button";
import { quizFormAction } from "@/app/server-actions/quiz-form";
import { useQuizOutputContext } from "@/context/quiz-output";
import { QuizQuestion } from "@/types/quiz-question";

async function handleSubmit(formData: FormData, setOutput: React.Dispatch<React.SetStateAction<QuizQuestion[]>>) {
  const response = await quizFormAction(formData);
	setOutput(response);
	console.log('from handleSubmit', response);
}

export default function InputSection() {
	const { setOutput } = useQuizOutputContext();

  return (
    <div
      className="relative hidden flex-col items-start gap-8 md:flex max-h-[calc(100vh-6rem)]"
      x-chunk="A settings form a configuring an AI model and messages."
    >
      <form action={formData => handleSubmit(formData, setOutput)} className="grid grid-rows-[1fr,1fr,auto] w-full h-full items-start gap-4">
				<Settings />
				<Prompt />
				<Button className="self-end">Submit</Button>
      </form>
    </div>
  );
}
