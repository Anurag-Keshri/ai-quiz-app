import Main from "./main";
import Header from "./header";
import Aside from "./aside";

export default function Dashboard() {
  return (
    <div className="grid h-screen w-full pl-[53px]">
			<Aside />
      <div className="flex flex-col">
				<Header />
				<Main />
      </div>
    </div>
  );
}
