import {describe, it, expect} from "vitest";
import LeftPane from "./LeftPane.vue";
import {mount, shallowMount} from "@vue/test-utils";
import Tabs from "@/components/Tabs.vue";
import Tab from "@/components/Tab.vue";
import LeftPaneSettings from "@/components/EditCB/LeftPaneSettings.vue";
import LeftPaneComponents from "@/components/EditCB/LeftPaneComponents.vue";

// describe('LeftPane', () => {
//     it.skip('renders the component', () => {
//         const wrapper = mount(LeftPane);
//         expect(wrapper.text()).toContain('Content Block');
//     });
//     it.skip('shallow mount', () => {
//         const wrapper = shallowMount(LeftPane);
//         expect(wrapper.text()).toContain('Content Block');
//     });
// });

describe('YourComponent', () => {

  const wrapper = mount(LeftPane, {
    global: {
      stubs: {
        Tabs,
        Tab,
        LeftPaneSettings,
        LeftPaneComponents,
      },
    },
  })

  test('should render with all necessary tabs', () => {
    expect(wrapper.findAllComponents(Tabs)).toHaveLength(1)
    expect(wrapper.findAllComponents(Tab)).toHaveLength(3)
  })

  test('should include correct components under each tab', () => {
    expect(wrapper.findComponent(LeftPaneSettings).exists()).toBe(true)
    expect(wrapper.findComponent(LeftPaneComponents).exists()).toBe(true)
    // similar check for the component under "Basics" tab
  })
})
