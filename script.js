// Constants
const SPECIALIZATION_OPTIONS = {
    'Pemrograman': [
        'Web Developer',
        'Mobile Developer',
        'Data Science',
        'Game Developer',
        'Backend Developer'
    ],
    'Jaringan': [
        'Network Administration',
        'Cloud Computing',
        'Cybersecurity',
        'System Administration',
        'DevOps'
    ],
    'Desain': [
        'UI/UX Design',
        'Graphic Design',
        'Motion Graphics',
        '3D Modeling',
        'Web Design'
    ]
};

// Form handlers
document.addEventListener('DOMContentLoaded', () => {
    initializeFormHandlers();
    setupPasswordToggles();
});

function initializeFormHandlers() {
    const bidangMinatSelect = document.getElementById('bidang_minat');
    const spesialisasi = document.getElementById('spesialisasi');

    const spesialisasiOptions = {
        'Pemrograman': [
            'Web Development',
            'Mobile Development',
            'Desktop Development',
            'Game Development',
            'Data Science'
        ],
        'Jaringan': [
            'Network Administration',
            'Cyber Security',
            'Cloud Computing',
            'System Administration',
            'DevOps'
        ],
        'Desain': [
            'UI/UX Design',
            'Graphic Design',
            'Motion Design',
            '3D Design',
            'Video Editing'
        ]
    };

    if (bidangMinatSelect) {
        bidangMinatSelect.addEventListener('change', function() {
            const selectedBidang = this.value;
            spesialisasi.innerHTML = '<option value="">Pilih Spesialisasi</option>';

            if (selectedBidang && spesialisasiOptions[selectedBidang]) {
                spesialisasiOptions[selectedBidang].forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option;
                    optionElement.textContent = option;
                    spesialisasi.appendChild(optionElement);
                });
                spesialisasi.disabled = false;
            } else {
                spesialisasi.disabled = true;
            }
        });
    }
}
