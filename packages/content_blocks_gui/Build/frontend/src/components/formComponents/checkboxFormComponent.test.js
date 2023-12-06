import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import CheckboxFormComponent from "@/components/formComponents/checkboxFormComponent.vue";
import { Field, ErrorMessage } from 'vee-validate';

describe('CheckboxFormComponent', () => {
    it('zeigt das Label korrekt an', () => {
        const label = "Test Label";
        const name = "testCheckbox";
        const isChecked = true;

        const wrapper = mount(CheckboxFormComponent, {
            global: {
                components: {
                    Field,
                    ErrorMessage,
                },
            },
            props: {
                label,
                isChecked,
                name,
            },
        });

        expect(wrapper.text()).toContain(label);
    });
});
