import { Bird, Rabbit, Turtle } from "lucide-react";

import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

function Model() {
  return (
    <div className="grid gap-3">
      <Label htmlFor="model">Model</Label>
      <Select name="model" disabled>
        <SelectTrigger
          id="model"
          className="items-start [&_[data-description]]:hidden"
        >
          <SelectValue placeholder="Select a model" />
        </SelectTrigger>
        <SelectContent>
          <SelectItem value="genesis">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Rabbit className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Neural{" "}
                  <span className="font-medium text-foreground">Genesis</span>
                </p>
                <p className="text-xs" data-description>
                  Our fastest model for general use cases.
                </p>
              </div>
            </div>
          </SelectItem>
          <SelectItem value="explorer">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Bird className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Neural{" "}
                  <span className="font-medium text-foreground">Explorer</span>
                </p>
                <p className="text-xs" data-description>
                  Performance and speed for efficiency.
                </p>
              </div>
            </div>
          </SelectItem>
          <SelectItem value="quantum">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Turtle className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Neural{" "}
                  <span className="font-medium text-foreground">Quantum</span>
                </p>
                <p className="text-xs" data-description>
                  The most powerful model for complex computations.
                </p>
              </div>
            </div>
          </SelectItem>
        </SelectContent>
      </Select>
    </div>
  );
}

function Questions() {
  return (
    <div className="grid gap-3">
      <Label htmlFor="questions">Questions</Label>
      <Input name="questions" id="questions" type="number" placeholder="10" defaultValue={10} min={1} max={50} />
    </div>
  );
}

function Options() {
  return (
    <div className="grid gap-3">
      <Label htmlFor="options">Options</Label>
      <Input name="options" id="options" type="number" placeholder="4" defaultValue={4} min={2} max={10} />
    </div>
  );
}

function Difficulty() {
  return (
    <div className="grid gap-3">
      <Label htmlFor="difficulty">Difficulty</Label>
      <Select name="difficulty" defaultValue="easy">
        <SelectTrigger
          id="difficulty"
          className="items-start [&_[data-description]]:hidden"
        >
          <SelectValue placeholder="Select a difficulty" />
        </SelectTrigger>
        <SelectContent>
          <SelectItem value="easy">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Bird className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Easy{" "}
                  <span className="font-medium text-foreground">
                    Difficulty
                  </span>
                </p>
                <p className="text-xs" data-description>
                  The easiest difficulty for beginners.
                </p>
              </div>
            </div>
          </SelectItem>
          <SelectItem value="medium">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Rabbit className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Medium{" "}
                  <span className="font-medium text-foreground">
                    Difficulty
                  </span>
                </p>
                <p className="text-xs" data-description>
                  The default difficulty for most users.
                </p>
              </div>
            </div>
          </SelectItem>
          <SelectItem value="hard">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Turtle className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Hard{" "}
                  <span className="font-medium text-foreground">
                    Difficulty
                  </span>
                </p>
                <p className="text-xs" data-description>
                  The most difficult difficulty for advanced users.
                </p>
              </div>
            </div>
          </SelectItem>
        </SelectContent>
      </Select>
    </div>
  );
}

function Depth() {
  return (
    <div className="grid gap-3">
      <Label htmlFor="depth">Depth</Label>
      <Select name="depth" defaultValue="shallow">
        <SelectTrigger
          id="depth"
          className="items-start [&_[data-description]]:hidden"
        >
          <SelectValue placeholder="Select a depth" />
        </SelectTrigger>
        <SelectContent>
          <SelectItem value="shallow">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Bird className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Shallow{" "}
                  <span className="font-medium text-foreground">Depth</span>
                </p>
                <p className="text-xs" data-description>
                  The shallowest depth for beginners.
                </p>
              </div>
            </div>
          </SelectItem>
          <SelectItem value="medium">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Rabbit className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Medium{" "}
                  <span className="font-medium text-foreground">Depth</span>
                </p>
                <p className="text-xs" data-description>
                  The default depth for most users.
                </p>
              </div>
            </div>
          </SelectItem>
          <SelectItem value="deep">
            <div className="flex items-start gap-3 text-muted-foreground">
              <Turtle className="size-5" />
              <div className="grid gap-0.5">
                <p>
                  Deep{" "}
                  <span className="font-medium text-foreground">Depth</span>
                </p>
                <p className="text-xs" data-description>
                  The deepest depth for advanced users.
                </p>
              </div>
            </div>
          </SelectItem>
        </SelectContent>
      </Select>
    </div>
  );
}

export default function Settings() {
  return (
    <fieldset className="grid gap-6 rounded-lg border p-4">
      <legend className="-ml-1 px-1 text-sm font-medium">Settings</legend>
      <Model />
      <div className="grid grid-cols-2 gap-4">
        <Questions />
        <Options />
        <Difficulty />
        <Depth />
      </div>
    </fieldset>
  );
}
