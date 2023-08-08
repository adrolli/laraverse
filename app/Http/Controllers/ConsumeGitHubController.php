<?php

namespace App\Http\Controllers;

use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GitHubController extends Controller
{
    public function searchRepositories($query)
    {
        $githubApiUrl = 'https://api.github.com/search/repositories';
        $accessToken = env('GH_ACCESS_TOKEN');
        $client = new Client();

        try {
            $response = $client->get($githubApiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.$accessToken,
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'q' => $query.'+in:title,tag',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Process the data or return it to the view...
            $repositories = $data['items'];
            $processedData = [];

            foreach ($repositories as $repository) {
                // Fetch detailed repository information
                $repoDetailsResponse = $client->get($repository['url'], [
                    'headers' => [
                        'Authorization' => 'Bearer '.$accessToken,
                        'Accept' => 'application/json',
                    ],
                ]);

                $repoDetails = json_decode($repoDetailsResponse->getBody(), true);

                // Fetch repository contents
                $contentsUrl = "https://api.github.com/repos/{$repoDetails['full_name']}/contents";

                $contentsResponse = $client->get($contentsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer '.$accessToken,
                        'Accept' => 'application/json',
                    ],
                ]);

                $contents = json_decode($contentsResponse->getBody(), true);

                // Check if the files exist
                $fileNames = ['composer.json', 'package.json', 'README.md', 'LICENSE.md'];
                $existingFiles = [];

                foreach ($fileNames as $fileName) {
                    $exists = false;
                    foreach ($contents as $content) {
                        if ($content['name'] === $fileName) {
                            $exists = true;
                            break;
                        }
                    }
                    $existingFiles[$fileName] = $exists;
                }

                // dd($repoDetails['security_and_analysis']);

                // Transform the data to match your schema
                $itemData = [
                    'title' => $repoDetails['full_name'],
                    'slug' => $repoDetails['full_name'],
                    'description' => $repoDetails['full_name'],
                    'vendor_id' => $repoDetails['id'],
                    'type_id' => $repoDetails['id'],
                    'website' => $repoDetails['full_name'],

                    // Map other fields here
                ];

                // Store the transformed data in the database
                Item::create($itemData);

                return response()->json(['message' => 'Item inserted successfully']);

                /*
                'github_id' => $repoDetails['id'],
                'github_node_id' => $repoDetails['node_id'],
                'github_name' => $repoDetails['name'],
                'github_full_name' => $repoDetails['full_name'],
                'github_private' => $repoDetails['private'],
                'github_html_url' => $repoDetails['html_url'],
                'github_description' => $repoDetails['description'],
                'github_fork' => $repoDetails['fork'],
                'github_url' => $repoDetails['url'],
                'github_forks_url' => $repoDetails['forks_url'],
                'github_keys_url' => $repoDetails['keys_url'],
                'github_collaborators_url' => $repoDetails['collaborators_url'],
                'github_teams_url' => $repoDetails['teams_url'],
                'github_issue_events_url' => $repoDetails['issue_events_url'],
                'github_events_url' => $repoDetails['events_url'],
                'github_assignees_url' => $repoDetails['assignees_url'],
                'github_branches_url' => $repoDetails['branches_url'],
                'github_tags_url' => $repoDetails['tags_url'],
                'github_blobs_url' => $repoDetails['blobs_url'],
                'github_git_tags_url' => $repoDetails['git_tags_url'],
                'github_git_refs_url' => $repoDetails['git_refs_url'],
                'github_trees_url' => $repoDetails['trees_url'],
                'github_statuses_url' => $repoDetails['statuses_url'],
                'github_languages_url' => $repoDetails['languages_url'],
                'github_stargazers_url' => $repoDetails['stargazers_url'],
                'github_contributors_url' => $repoDetails['contributors_url'],
                'github_subscribers_url' => $repoDetails['subscribers_url'],
                'github_subscription_url' => $repoDetails['subscription_url'],
                'github_commits_url' => $repoDetails['commits_url'],
                'github_git_commits_url' => $repoDetails['git_commits_url'],
                'github_comments_url' => $repoDetails['comments_url'],
                'github_issue_comment_url' => $repoDetails['issue_comment_url'],
                'github_contents_url' => $repoDetails['contents_url'],
                'github_compare_url' => $repoDetails['compare_url'],
                'github_merges_url' => $repoDetails['merges_url'],
                'github_archive_url' => $repoDetails['archive_url'],
                'github_downloads_url' => $repoDetails['downloads_url'],
                'github_issues_url' => $repoDetails['issues_url'],
                'github_pulls_url' => $repoDetails['pulls_url'],
                'github_milestones_url' => $repoDetails['milestones_url'],
                'github_notifications_url' => $repoDetails['notifications_url'],
                'github_labels_url' => $repoDetails['labels_url'],
                'github_releases_url' => $repoDetails['releases_url'],
                'github_deployments_url' => $repoDetails['deployments_url'],
                'github_created_at' => $repoDetails['created_at'],
                'github_updated_at' => $repoDetails['updated_at'],
                'github_pushed_at' => $repoDetails['pushed_at'],
                'github_git_url' => $repoDetails['git_url'],
                'github_ssh_url' => $repoDetails['ssh_url'],
                'github_clone_url' => $repoDetails['clone_url'],
                'github_svn_url' => $repoDetails['svn_url'],
                'github_homepage' => $repoDetails['homepage'],
                'github_size' => $repoDetails['size'],
                'github_stargazers_count' => $repoDetails['stargazers_count'],
                'github_watchers_count' => $repoDetails['watchers_count'],
                'github_language' => $repoDetails['language'],
                'github_has_issues' => $repoDetails['has_issues'],
                'github_has_projects' => $repoDetails['has_projects'],
                'github_has_downloads' => $repoDetails['has_downloads'],
                'github_has_wiki' => $repoDetails['has_wiki'],
                'github_has_pages' => $repoDetails['has_pages'],
                'github_has_discussions' => $repoDetails['has_discussions'],
                'github_forks_count' => $repoDetails['forks_count'],
                'github_mirror_url' => $repoDetails['mirror_url'],
                'github_archived' => $repoDetails['archived'],
                'github_disabled' => $repoDetails['disabled'],
                'github_open_issues_count' => $repoDetails['open_issues_count'],
                'github_license_key' => $repoDetails['license']['key'],
                'github_license_name' => $repoDetails['license']['name'],
                'github_license_spdx_id' => $repoDetails['license']['spdx_id'],
                'github_license_url' => $repoDetails['license']['url'],
                'github_license_node_id' => $repoDetails['license']['node_id'],
                'github_allow_forking' => $repoDetails['allow_forking'],
                'github_is_template' => $repoDetails['is_template'],
                'github_web_commit_signoff_required' => $repoDetails['web_commit_signoff_required'],
                'github_visibility' => $repoDetails['visibility'],
                'github_forks' => $repoDetails['forks'],
                'github_open_issues' => $repoDetails['open_issues'],
                'github_watchers' => $repoDetails['watchers'],
                'github_default_branch' => $repoDetails['default_branch'],
                'github_permissions_admin' => $repoDetails['permissions']['admin'],
                'github_permissions_maintain' => $repoDetails['permissions']['maintain'],
                'github_permissions_push' => $repoDetails['permissions']['push'],
                'github_permissions_triage' => $repoDetails['permissions']['triage'],
                'github_permissions_pull' => $repoDetails['permissions']['pull'],
                'github_temp_clone_token' => $repoDetails['temp_clone_token'],
                'github_allow_squash_merge' => $repoDetails['allow_squash_merge'],
                'github_allow_merge_commit' => $repoDetails['allow_merge_commit'],
                'github_allow_rebase_merge' => $repoDetails['allow_rebase_merge'],
                'github_allow_auto_merge' => $repoDetails['allow_auto_merge'],
                'github_delete_branch_on_merge' => $repoDetails['delete_branch_on_merge'],
                'github_allow_update_branch' => $repoDetails['allow_update_branch'],
                'github_use_squash_pr_title_as_default' => $repoDetails['use_squash_pr_title_as_default'],
                'github_squash_merge_commit_message' => $repoDetails['squash_merge_commit_message'],
                'github_squash_merge_commit_title' => $repoDetails['squash_merge_commit_title'],
                'github_merge_commit_message' => $repoDetails['merge_commit_message'],
                'github_merge_commit_title' => $repoDetails['merge_commit_title'],
                'github_security_and_analysis_secret_scanning_status' => $repoDetails['security_and_analysis']['secret_scanning']['status'],
                'github_security_and_analysis_secret_scanning_push_protection_status' => $repoDetails['security_and_analysis']['secret_scanning_push_protection']['status'],
                'github_security_and_analysis_dependabot_security_updates_status' => $repoDetails['security_and_analysis']['dependabot_security_updates']['status'],
                'github_network_count' => $repoDetails['network_count'],
                'github_subscribers_count' => $repoDetails['subscribers_count'],

                // org
                'github_organization_login' => $repoDetails['organization']['login'],
                'github_organization_id' => $repoDetails['organization']['id'],
                'github_organization_node_id' => $repoDetails['organization']['node_id'],
                'github_organization_avatar_url' => $repoDetails['organization']['avatar_url'],
                'github_organization_gravatar_id' => $repoDetails['organization']['gravatar_id'],
                'github_organization_url' => $repoDetails['organization']['url'],
                'github_organization_html_url' => $repoDetails['organization']['html_url'],
                'github_organization_followers_url' => $repoDetails['organization']['followers_url'],
                'github_organization_following_url' => $repoDetails['organization']['following_url'],
                'github_organization_gists_url' => $repoDetails['organization']['gists_url'],
                'github_organization_starred_url' => $repoDetails['organization']['starred_url'],
                'github_organization_subscriptions_url' => $repoDetails['organization']['subscriptions_url'],
                'github_organization_organizations_url' => $repoDetails['organization']['organizations_url'],
                'github_organization_repos_url' => $repoDetails['organization']['repos_url'],
                'github_organization_events_url' => $repoDetails['organization']['events_url'],
                'github_organization_received_events_url' => $repoDetails['organization']['received_events_url'],
                'github_organization_type' => $repoDetails['organization']['type'],
                'github_organization_site_admin' => $repoDetails['organization']['site_admin'],

                // owner
                'github_owner_login' => $repoDetails['owner']['login'],
                'github_owner_id' => $repoDetails['owner']['id'],
                'github_owner_node_id' => $repoDetails['owner']['node_id'],
                'github_owner_avatar_url' => $repoDetails['owner']['avatar_url'],
                'github_owner_gravatar_id' => $repoDetails['owner']['gravatar_id'],
                'github_owner_url' => $repoDetails['owner']['url'],
                'github_owner_html_url' => $repoDetails['owner']['html_url'],
                'github_owner_followers_url' => $repoDetails['owner']['followers_url'],
                'github_owner_following_url' => $repoDetails['owner']['following_url'],
                'github_owner_gists_url' => $repoDetails['owner']['gists_url'],
                'github_owner_starred_url' => $repoDetails['owner']['starred_url'],
                'github_owner_subscriptions_url' => $repoDetails['owner']['subscriptions_url'],
                'github_owner_organizations_url' => $repoDetails['owner']['organizations_url'],
                'github_owner_repos_url' => $repoDetails['owner']['repos_url'],
                'github_owner_events_url' => $repoDetails['owner']['events_url'],
                'github_owner_received_events_url' => $repoDetails['owner']['received_events_url'],
                'github_owner_type' => $repoDetails['owner']['type'],
                'github_owner_site_admin' => $repoDetails['owner']['site_admin'],


                // foreach topics
                'github_topics_' => $repoDetails['topics'][''],

                */

                echo "Repository: {$repoDetails['full_name']}<br>";
                echo "Owner: {$repoDetails['owner']['login']}<br>";
                echo "Default-Branch: {$repoDetails['default_branch']}<br>";
                echo 'Files:<br>';
                foreach ($existingFiles as $fileName => $exists) {
                    echo "- $fileName: ".($exists ? 'Exists' : 'Does not exist').'<br>';
                }
                echo '<br>';

                // Rest of your code to process other details
                // ...

                $processedData[] = $repoDetails;
            }

            return $processedData;
        } catch (Exception $e) {
            // Handle API request errors here.
        }
    }

    public function getRepositoryInfo($repo)
    {

    }

    public function getRepositoryFiles($repo)
    {

    }
}
