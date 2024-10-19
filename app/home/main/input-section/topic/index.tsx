import { Textarea } from "@/components/ui/textarea"

export default function Prompt() {
  return (
    <fieldset className="grid gap-6 rounded-lg border p-4 h-full">
      <legend className="-ml-1 px-1 text-sm font-medium">Topic</legend>
      <div className="grid gap-3">
        <Textarea
          id="content"
					name="topic"
          placeholder="HTML"
          className="min-h-[9.5rem]"
        />
      </div>
    </fieldset>
  );
}
