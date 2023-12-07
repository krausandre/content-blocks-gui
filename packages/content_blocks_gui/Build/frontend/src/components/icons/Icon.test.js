import {flushPromises, shallowMount} from '@vue/test-utils';
import Icon from '@/components/icons/Icon.vue';
import { describe, it, expect } from 'vitest';

// Mock für top.TYPO3.Icons.getIcon
global.top = {
  TYPO3: {
    Icons: {
      getIcon: () => Promise.resolve('<svg>Mocked SVG</svg>')
    }
  }
};

describe('Icon', () => {
    it('renders correctly', async () => {
        const wrapper = shallowMount(Icon, {
            propsData: {
                identifier: 'some-icon',
                size: 'small'
            }
        });
        // Warte darauf, dass Promises gelöst werden
        await flushPromises();

        expect(wrapper.exists()).toBe(true);
        expect(wrapper.html()).toContain('<div><svg>Mocked SVG</svg></div>');
    });
});

