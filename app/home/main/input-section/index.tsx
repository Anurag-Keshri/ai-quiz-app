import Settings from "./settings";
import Prompt from "./prompt";
import { Button } from "@/components/ui/button";

export default function InputSection() {
  return (
    <div
      className="relative hidden flex-col items-start gap-8 md:flex"
      x-chunk="A settings form a configuring an AI model and messages."
    >
      <form className="grid w-full h-full items-start gap-6">
				<Settings />
				<Prompt />
				<Button className="self-end">Submit</Button>
      </form>
    </div>
  );
}
