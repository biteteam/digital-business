// @ts-nocheck
console.clear();

const provinceEl = document.querySelector("#province")
const cityEl = document.querySelector("#city")

async function getProvince() {
    const provinces = await fetch("/api/province", {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(res => res.json())


    let html = "<option disabled>Pilih Provinsi</option>";
    provinces.forEach(province => {
        const option = `<option value="${province.province_id}">${province.province}</option>`
        html += option
    });

    provinceEl.innerHTML = html;
}

async function getCity() {
    const provinceOptEl = provinceEl.options[provinceEl.selectedIndex];
    const prov = { id: provinceOptEl.value, provice: provinceOptEl.textContent }

    const cities = await fetch(`/api/city/${prov.id}`, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(res => res.json())

    let html = "<option disabled>Pilih Kota</option>";
    cities.forEach(city => {
        const option = `<option value="${city.city_id}">${city.city_name}</option>`
        html += option
    });

    cityEl.innerHTML = html;
}

// ===================================
provinceEl?.addEventListener("change", (e) => {
    cityEl.innerHTML = "<option>memuat kota...</option>";
    getCity()
});
getProvince()