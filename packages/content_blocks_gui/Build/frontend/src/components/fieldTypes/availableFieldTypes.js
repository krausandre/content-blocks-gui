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
                    max: 255,
                    min: 0,
                    placeholder: '',
                    required: false,
                    size: 255,
                },
            },
            {
                label: "Textarea",
                componentName: 'TextAreaFieldType',
                identifier: 'textarea',
                iconIdentifier: 'form-textarea',
                properties:
                {
                    cols: 50,
                    max: 255,
                    min: 0,
                    placeholder: '',
                    required: false,
                    rows: 5,
                },
            }
        ],
    };


export default availableFieldTypes;
