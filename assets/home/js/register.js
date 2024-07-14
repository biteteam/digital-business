// @ts-nocheck
console.clear();

const provinceEl = document.querySelector("#province")
const cityEl = document.querySelector("#city")
const addressEl = document.querySelector("#alamat")

let provinces = []
let cities = []

const getById = (source, searchKey, searchValue) => {
    for (const src of source) {
        if (String(src[searchKey]) == String(searchValue)) return src;
    }
}

async function getProvince() {
    const resultProvinces = await fetch("/api/province", {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(res => res.json())
    provinces = resultProvinces

    let html = "<option disabled>Pilih Provinsi</option>";
    resultProvinces.forEach(province => {
        const option = `<option value="${province.province_id}">${province.province}</option>`
        html += option
    });
    provinceEl.innerHTML = html;
    if (!cities?.length) getCity(1)
}

async function getCity(provinceId) {
    addressEl.innerHTML = ""
    const provinceOpt = provinceEl.options[provinceEl.selectedIndex];
    const prov = { id: provinceId ?? provinceOpt.value, provice: provinceOpt.textContent }

    const resultCities = await fetch(`/api/city/${prov.id}`, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(res => res.json())
    cities = resultCities

    let html = "<option disabled>Pilih Kota</option>";
    resultCities.forEach(city => {
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

cityEl.addEventListener("change", () => {
    const city = getById(cities, "city_id", cityEl.options[cityEl.selectedIndex]?.value)
    const type = city?.type == "Kabupaten" ? "Kab. " : ""

    const address = `${type}${city.city_name}, ${city.province}, Indonesia (${city.postal_code})`
    addressEl.innerHTML = address
})