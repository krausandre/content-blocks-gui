import { mount } from '@vue/test-utils';
import Tab from './Tab.vue';
import { describe, it, expect, beforeEach } from 'vitest';

describe('Tab', () => {
    it('renders correctly', () => {
        const wrapper = mount(Tab);
        expect(wrapper.exists()).toBe(true);
    });

    it('is visible when active is true', () => {
        const wrapper = mount(Tab, {
            props: { active: 'true' }
        });
        expect(wrapper.find('.tab').classes()).toContain('active');
    });

    it('is not visible when active is not true', () => {
        const wrapper = mount(Tab, {
            props: { active: 'false' }
        });
        expect(wrapper.find('.tab').classes()).not.toContain('active');
    });
});
