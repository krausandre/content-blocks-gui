const availableFieldTypes =
    {
        inputFields: [
            {
                label: 'Text',
                componentName: 'TextFieldType',
                identifier: 'text',
                iconIdentifier: 'form-text',
                properties:
                {
                    default: '',
                    required: false,
                    minLength: 0,
                    maxLength: 255,
                    size: 255,
                    placeholder: '',
                    valuePicker: [],
                },
            },
            {
                label: "Textarea",
                componentName: 'TextAreaFieldType',
                identifier: 'textarea',
                iconIdentifier: 'form-textarea',
                properties:
                {
                    default: '',
                    placeholder: '',
                    rows: 5,
                    required: false,
                    enableRichtext: false,
                    richtextConfiguration: 255
                },
            },
            {
                label: "Checkbox",
                componentName: 'CheckboxFieldType',
                identifier: 'checkbox',
                iconIdentifier: 'form-checkbox',
                properties:
                {
                    default: false,
                    required: false,
                    items: [],
                },
            }
        ],
    };


export default availableFieldTypes;
