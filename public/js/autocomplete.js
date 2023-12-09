    let dbtags = [];

    window.onload = async () => {
        const url = '../api/users';
        const response = await fetch(url);
        const allTags = await response.json();
        dbtags = allTags.map(tag => tag.username).filter(Boolean);
        console.log(dbtags);
    };

    const input = document.querySelector('#user');
    if (input) {
        let matchingTags = [];
        let index = 0;
        
        input.addEventListener('input', function (event) {
            console.log('input');
            const tag = input.value.toUpperCase();
        
            if (tag === '') return;
        
            matchingTags = dbtags.filter(dbtag => dbtag && dbtag.toUpperCase().startsWith(tag)).filter(Boolean);
        });

        input.addEventListener('keydown', async function (event) {
            console.log('keydown');
            if (event.key === 'Tab') {
                event.preventDefault();
                if (matchingTags.length > 0) {
                    input.value = matchingTags[index];
                    index = (index + 1) % matchingTags.length;
                }
            }

        });
    }