import { describe, it, expect, test, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import InputFormComponent from './inputFormComponent.vue';
import { Field, ErrorMessage, defineRule } from 'vee-validate';

// Set up the 'required' validation rule
defineRule('required', value => !!value || 'This field is required.');

describe('InputFormComponent', () => {

    // Test for label rendering
    it('correctly displays the label', () => {
        const label = "Test Label";
        const wrapper = mount(InputFormComponent, {
            props: {
                label,
                name: 'testInput'
            },
        });

        expect(wrapper.text()).toContain(label);
    });

    // Test for value rendering
    it('correctly displays the value', () => {
        const value = "Test Value";
        const wrapper = mount(InputFormComponent, {
            props: {
                value,
                modelValue: value,
                name: 'testInput'
            },
        });

        expect(wrapper.text()).toContain(`value: ${value}`);
    });

    // Test for the existence of Field component
    it('renders a Field component', () => {
        const wrapper = mount(InputFormComponent, {
            props: {
                name: 'testInput'
            },
        });

        expect(wrapper.findComponent(Field).exists()).toBe(true);
    });

    // Test for error message visibility after interaction
    it('displays an error message after interaction and deletion', async () => {
        expect(true).toBe(true);
        console.log('TODO: muss noch diesen Test implementieren');
    });

    it('shows the error message with rule minLength: 5', async () => {
        expect(true).toBe(true);
        console.log('TODO: muss noch diesen Test implementieren');
    });

    it('shows the error message with rule email', async () => {
        expect(true).toBe(true);
        console.log('TODO: muss noch diesen Test implementieren');
    });
});
