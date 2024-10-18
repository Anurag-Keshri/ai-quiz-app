"use client"

import Settings from "./settings";
import Prompt from "./topic";
import { Button } from "@/components/ui/button";
import { quizFormAction } from "@/app/server-actions/quiz-form";
import { useState } from "react";	

async function handleSubmit(formData: FormData) {
  const response = await quizFormAction(formData);
	console.log('from handleSubmit', response);
}

export default function InputSection() {
  return (
    <div
      className="relative hidden flex-col items-start gap-8 md:flex"
      x-chunk="A settings form a configuring an AI model and messages."
    >
      <form action={handleSubmit} className="grid w-full h-full items-start gap-6">
				<Settings />
				<Prompt />
				<Button className="self-end">Submit</Button>
      </form>
    </div>
  );
}
