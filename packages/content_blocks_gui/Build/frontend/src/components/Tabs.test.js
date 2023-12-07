import { mount } from '@vue/test-utils';
import Tabs from './Tabs.vue';
import { describe, it, expect, beforeEach } from 'vitest';


describe('Tabs', () => {
  let wrapper;

  beforeEach(() => {
    wrapper = mount(Tabs, {
      props: {
        customClass: 'custom-class',
        tabs: [
          { title: 'Tab 1' },
          { title: 'Tab 2' },
          { title: 'Tab 3' }
        ]
      }
    });
  });

  it('renders correctly', () => {
    expect(wrapper.exists()).toBe(true);
  });
});
