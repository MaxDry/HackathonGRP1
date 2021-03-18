const resetAll = (onglets, containers) => {
    [...onglets, ...containers].forEach(onglet => {
        onglet.classList.remove('active');
    })
}

const dragAndDropRoles = (page) => {
    const onglets = page.querySelectorAll('.onglets .onglet');
    const containers = page.querySelectorAll('.container-roles');

    containers[0].classList.add('active');

    onglets && containers && [...onglets].forEach(onglet => {
        onglet.addEventListener('click', e => {
            resetAll(onglets, containers);
            e.target.classList.add('active');
            const name = onglet.dataset.name;
            if (name) {
                const currentContainer = page.querySelector(`.container-roles.${name}`);
                currentContainer.classList.add('active');
            }
        });
    });
}

let profile = document.querySelector('.form-type[name="profile"]');

if (!profile) {
    profile = document.querySelector('.show-type.profiles');
}

profile && dragAndDropRoles(profile);