import { createContext, useContext, useState } from "react";
import { QuizQuestion } from "@/app/types/quiz-question";

interface QuizOutputContextValue {
  output: QuizQuestion[];
  setOutput: React.Dispatch<React.SetStateAction<QuizQuestion[]>>;
}

const QuizOutputContext = createContext<QuizOutputContextValue | undefined>(undefined);

export const QuizOutputProvider = ({children}: {children: React.ReactNode}) => {
  const [output, setOutput] = useState([] as QuizQuestion[]);
  return (
    <QuizOutputContext.Provider value={{output, setOutput}}>
      {children}
    </QuizOutputContext.Provider>
  );
};

export const useQuizOutputContext = () => {
  const quizOutputContext = useContext(QuizOutputContext);
  if (quizOutputContext === undefined) {
    throw new Error('useQuizOutputContext must be inside a QuizOutputProvider');
  }
  return quizOutputContext;
};
