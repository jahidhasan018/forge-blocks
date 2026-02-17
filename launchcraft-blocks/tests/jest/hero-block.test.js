import metadata from '../../src/Modules/Hero/block.json';

describe('Hero block metadata', () => {
	it('uses dynamic save strategy', () => {
		expect(metadata.name).toBe('forge/hero');
		expect(metadata.editorScript).toContain('hero');
	});
});
