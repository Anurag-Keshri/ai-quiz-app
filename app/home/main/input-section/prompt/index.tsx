import { Label } from "@/components/ui/label"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import { Textarea } from "@/components/ui/textarea"

export default function Prompt() {
  return (
    <fieldset className="grid gap-6 rounded-lg border p-4 h-full">
      <legend className="-ml-1 px-1 text-sm font-medium">Prompt</legend>
      <div className="grid gap-3">
        <Textarea
          id="content"
					name="textarea1"
          placeholder="You are a..."
          className="min-h-[9.5rem]"
        />
      </div>
    </fieldset>
  );
}
