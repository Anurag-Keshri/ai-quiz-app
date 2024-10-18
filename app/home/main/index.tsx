import InputSection from "./input-section";
import OutputSection from "./output-section";

export default function MainSection() {
  return (
    <main className="grid flex-1 gap-4 overflow-auto p-4 md:grid-cols-2 lg:grid-cols-3">
      <InputSection />
      <OutputSection />
    </main>
  );
}
