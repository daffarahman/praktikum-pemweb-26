const apiMeow = "https://meowfacts.herokuapp.com/";
const githubUser = "daffarahman";
const apiGithub = "https://api.github.com";
const perPage = 5;

$(document).ready(function () {
    const currentFile = window.location.pathname.split('/').pop().trim();
    const urlParams = new URLSearchParams(window.location.search);

    // So I don't need to rewrite the navbar in each html file
    $('#header')
        .addClass('flex justify-around items-center py-4')
        .load('components/header.html');

    // Fetch the repo list data from my github and list only 5 of it in a table
    if (currentFile === 'index.html') {
        $.ajax({
            url: `${apiGithub}/users/${githubUser}/repos?per_page=${perPage}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                const $projectList = $('#project-list');

                $projectList.empty();

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
                    $projectList.append(rowHtml);
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching project data:', error);
            }
        });
    }

    // Display the repo detail, taken from the name
    else if (currentFile === 'project.html') {
        const projectName = urlParams.get('name');

        $.ajax({
            url: `${apiGithub}/repos/${githubUser}/${projectName}`,
            method: 'GET',
            dataType: 'json',
            success: function (repo) {
                const $content = $('#detail-content');
                $('#detail-loading').addClass('hidden');
                $content.removeClass('hidden');

                const lastUpdated = new Date(repo.updated_at).toLocaleDateString(undefined, {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                const licenseName = repo.license ? repo.license.name : 'No License';
                const projectLanguage = repo.language ? repo.language : 'N/A';
                const projectDescription = repo.description ? repo.description : 'No description provided.';

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

                $content.html(detailHtml);
            },
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