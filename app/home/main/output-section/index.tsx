import { Badge } from "@/components/ui/badge";
import { useContext } from "react";
import { useQuizOutputContext } from "@/context/quiz-output";

export default function OutputSection() {
	const { output } = useQuizOutputContext();
  return (
    <div className="relative flex h-full flex-col rounded-xl bg-muted/50 p-4 lg:col-span-2 max-h-[calc(100vh-6rem)] min-h-[554px] overflow-y-scroll">
      <Badge variant="outline" className="absolute right-3 top-3">
        Output
      </Badge>
			{output.map((question, index) => (
				<div key={index} className="flex flex-col gap-2">
					<p>{question.question}</p>
					<p>{JSON.stringify(question.options)}</p>
					<p>{question.correctAnswer}</p>
				</div>
			))}
    </div>
  );
}
