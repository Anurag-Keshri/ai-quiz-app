import { Badge } from "@/components/ui/badge";
import { useContext } from "react";
import { useQuizOutputContext } from "@/context/quiz-output";

export default function OutputSection() {
	const { output } = useQuizOutputContext();
  return (
    <div className="relative flex h-full min-h-[50vh] flex-col rounded-xl bg-muted/50 p-4 lg:col-span-2">
      <Badge variant="outline" className="absolute right-3 top-3">
        Output
      </Badge>
			{JSON.stringify(output)}
    </div>
  );
}
