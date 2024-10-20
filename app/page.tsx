import Aside from "./home/aside";
import Header from "./home/header";
import Main from "./home/main";

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
