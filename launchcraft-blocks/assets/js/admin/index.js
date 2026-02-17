import { createRoot } from 'react-dom/client';
import { useEffect, useState, createContext, useContext } from 'react';
import { Button, Card, CardBody, Flex, FlexBlock, FlexItem, ToggleControl, Spinner } from '@wordpress/components';

const ModulesContext = createContext(null);

const Sidebar = () => (
	<Card className="lc-admin-sidebar">
		<CardBody>
			<h2>Forge</h2>
			<ul>
				<li>Modules</li>
				<li>Global Styles</li>
			</ul>
		</CardBody>
	</Card>
);

const ModuleList = () => {
	const { modules, setModules } = useContext(ModulesContext);
	return modules.map((module) => (
		<ToggleControl
			key={module.slug}
			label={module.name}
			checked={module.enabled}
			onChange={(enabled) => {
				setModules((prev) => prev.map((item) => (item.slug === module.slug ? { ...item, enabled } : item)));
			}}
		/>
	));
};

const App = () => {
	const [modules, setModules] = useState([]);
	const [loading, setLoading] = useState(true);

	useEffect(() => {
		window
			.fetch(ForgeAdmin.restUrl, {
				headers: { 'X-WP-Nonce': ForgeAdmin.nonce },
			})
			.then((response) => response.json())
			.then((data) => {
				setModules(data);
				setLoading(false);
			});
	}, []);

	const save = () => {
		const states = modules.reduce((carry, module) => ({ ...carry, [module.slug]: module.enabled }), {});
		window.fetch(ForgeAdmin.restUrl, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': ForgeAdmin.nonce,
			},
			body: JSON.stringify({ states }),
		});
	};

	if (loading) {
		return <Spinner />;
	}

	return (
		<ModulesContext.Provider value={{ modules, setModules }}>
			<Flex className="lc-admin-layout">
				<FlexItem>
					<Sidebar />
				</FlexItem>
				<FlexBlock>
					<Card>
						<CardBody>
							<h1>Module Management</h1>
							<ModuleList />
							<Button variant="primary" onClick={save}>
								Save Settings
							</Button>
						</CardBody>
					</Card>
				</FlexBlock>
			</Flex>
		</ModulesContext.Provider>
	);
};

const rootElement = document.getElementById('forge-admin-app');
if (rootElement) {
	createRoot(rootElement).render(<App />);
}
