// Muhammad Daffa Rahman - L0124062

// Constants yang dipakai
const githubUser = "daffarahman";
const apiGithub = "https://api.github.com";
const perPage = 5;

// Saat htmlnya siap
$(document).ready(function () {
    // Di sini ngambil current html file (index.html or project.html)
    const currentFile = window.location.pathname.split('/').pop().trim();

    // Ngambil parameter yang dikasih misal project.html?name=linux
    const urlParams = new URLSearchParams(window.location.search);

    // Ngambil isi file components/header.html biar tidak perlu nulis ulang navbarnya
    $('#header')
        .addClass('flex justify-around items-center py-4')
        .load('components/header.html');


    // Khusus index.html
    if (currentFile === 'index.html') {
        // fetch repo list data dengan maksimal 5 data pakai ajax
        $.ajax({
            url: `${apiGithub}/users/${githubUser}/repos?per_page=${perPage}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Kosongkan isi projectList terlebih dahulu
                const $projectList = $('#project-list');
                $projectList.empty();

                // Untuk setiap data...
                data.forEach(function (project) {
                    const rowHtml = `
                    <tr class="relative hover:bg-slate-100 duration-200 cursor-pointer">
                        <td class="px-6 py-4 font-medium text-slate-800">
                            <a href="project.html?name=${project.name}" class="after:absolute after:inset-0 focus:outline-none">
                                ${project.name}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            ${project.description}
                        </td>
                    </tr>
                `;
                    // append setiap isi pada elemen dengan rowHtml
                    $projectList.append(rowHtml);
                });
            },
            // Error
            error: function (xhr, status, error) {
                console.error('Error fetching project data:', error);
            }
        });
    }

    // Untuk project.html dan pastikan terdapat parameter name
    else if (currentFile === 'project.html' && urlParams.get('name') != null) {
        const projectName = urlParams.get('name');

        // Ambil data detail repository pakai ajax
        $.ajax({
            url: `${apiGithub}/repos/${githubUser}/${projectName}`,
            method: 'GET',
            dataType: 'json',
            success: function (repo) {

                // jika sukses, hide informasi loading
                const $content = $('#detail-content');
                $('#detail-loading').addClass('hidden');
                $content.removeClass('hidden');

                // Format informasi tanggal
                const lastUpdated = new Date(repo.updated_at).toLocaleDateString(undefined, {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                // Untuk berjaga-jaga jika beberapa informasi repo null / undefined
                const licenseName = repo.license ? repo.license.name : 'No License';
                const projectLanguage = repo.language ? repo.language : 'N/A';
                const projectDescription = repo.description ? repo.description : 'No description provided.';

                // Menampilkan beberapa data dari response ke bentuk html
                const detailHtml = `
                    <div class="flex flex-col gap-3 pt-4">
                        <img src="${repo.owner.avatar_url}" alt="${repo.owner.login}" class="w-16 h-16 rounded-full border border-slate-200">
                        <div class="text-xl">
                            <a href="${repo.owner.html_url}" target="_blank" rel="noopener noreferrer" class="font-medium text text-slate-900 hover:underline">${repo.owner.login}'s</a>
                        </div>
                    </div>

                    <div class="flex flex-col items-start">
                        <div>
                            <a href="${repo.html_url}" target="_blank" rel="noopener noreferrer" class="text-2xl font-semibold hover:underline">
                                ${repo.name}
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-slate-800 leading-relaxed">${projectDescription}</p>
                        </div>
                    </div>

                    <table class="min-w-full text-sm text-left border-collapse mt-4">
                        <tbody>
                            <tr>
                                <td class="py-2 pr-4 text-slate-600 w-1/3">Language</td>
                                <td class="py-2 font-medium text-slate-900">${projectLanguage}</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 text-slate-600">License</td>
                                <td class="py-2 font-medium text-slate-900">${licenseName}</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 text-slate-600">Last Updated</td>
                                <td class="py-2 font-medium text-slate-900">${lastUpdated}</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 text-slate-600">Stars</td>
                                <td class="py-2 font-medium text-slate-900">${repo.stargazers_count}</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 text-slate-600">Forks</td>
                                <td class="py-2 font-medium text-slate-900">${repo.forks_count}</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 text-slate-600">Open Issues</td>
                                <td class="py-2 font-medium text-slate-900">${repo.open_issues_count}</td>
                            </tr>
                        </tbody>
                    </table>
                `;

                // ubah isi htmlnya jadi detailHtml
                $content.html(detailHtml);
            },

            // Tampilkan error pada #project-detail apabila terdapat error saat fetching
            error: function (xhr, status, error) {
                console.error('Error fetching project details:', error);
                $('#project-detail').html(`
                <div class="text-center py-8 font-medium text-red-600">
                    Failed to load project details. Please try again later.
                </div>
            `);
            }
        });
    }

});