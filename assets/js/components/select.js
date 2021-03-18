import SelectPure from "select-pure";

const designSelectField = (selects) => {
    [...selects].forEach(select => {
        const isMultiple = select.classList.contains('multiple');
        const isAutocomplete = select.classList.contains('autocomplete');
        const selectedOptions = select.querySelector("select").selectedOptions;
        const data = [];
        let defaultValues = [];
        const options = select.querySelectorAll("option");
        options && [...options].forEach(option => {
            [...selectedOptions].forEach(opt => {
                opt.setAttribute('selected', 'selected');
            })

            data.push({label : option.text, value : option.value !== "" ? option.value : "null" });
            if (option.hasAttribute('selected')) {
                if (isMultiple) {
                    defaultValues.push(option.value);
                } else {
                    defaultValues = option.value;
                }
            }
        });

        const newSelect = new SelectPure(select, {
            options: data,
            multiple: isMultiple,
            autocomplete: isAutocomplete,
            value: defaultValues,
            icon: 'icon-own-cross',
            onChange: (values) => {
                [...options].forEach(option => {
                    if (isMultiple ? values.includes(option.value) : values === option.value || (values === "null" && option.value === "")) {
                        option.setAttribute('selected', 'selected');
                    } else {
                        option.removeAttribute('selected');
                    }
                });
            }
        });

        if (newSelect._autocomplete) {
            const input = select.querySelector('select');
            newSelect._autocomplete._node.placeholder = input.dataset.search;
        }

        if (!newSelect._config.multiple && newSelect._label._node.innerHTML === "" && selectedOptions.length > 0) {
            newSelect._label._node.innerHTML = selectedOptions[0].text;
            let value = selectedOptions[0].value ? selectedOptions[0].value : "null";
            [...newSelect._options].forEach(opt => {
                if (opt._node.dataset.value === value) {
                    opt._node.classList.add('select-pure__option--selected');
                }
            });
        }
    });
}

const selects = document.querySelectorAll("form .custom-select");
selects && designSelectField(selects);