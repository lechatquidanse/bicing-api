#!/usr/bin/env bash

MERGE_REQUESTS_URL="https://gitlab.com/api/v4/projects/${CI_PROJECT_ID}/merge_requests?target_branch=master"
MERGE_REQUESTS=$(curl  --header "PRIVATE-TOKEN: ${REPOSITORY_PRIVATE_TOKEN}" ${MERGE_REQUESTS_URL})
SHA=$(echo ${MERGE_REQUESTS} | jq 'first(.[] | select(.state == "merged") | .sha)')

if [ -z "SHA" ]; then
  echo "Required merge request SHA not found in pipeline"
  exit 1
fi

JOBS_URL="https://gitlab.com/api/v4/projects/${CI_PROJECT_ID}/jobs"
JOBS=$(curl  --header "PRIVATE-TOKEN: ${REPOSITORY_PRIVATE_TOKEN}" ${JOBS_URL})
JOB=$(echo ${PIPELINES} | jq 'first(.[] | select(.commit.id == "${SHA}" and .stage == "build"))')

if [ -z "JOB" ]; then
  echo "Required job not found in pipeline for commit: ${SHA} and stage= build"
  exit 1
fi

status=$(echo ${JOB} | jq '.status')
coverage=$(echo ${JOB} | jq '.coverage')
ref=$(echo ${JOB} | jq '.pipeline.ref')

if [ status == 'success' ]
then
    status_color='green'
else
    status_color='red'
fi

BADGE_BUILD=$(curl "https://img.shields.io/badge/build-"${status}"-"${status_color}".svg" | base64)
BADGE_COVERAGE=$(curl "https://img.shields.io/badge/coverage-"${coverage}"-green.svg" | base64)
BADGE_REF=$(curl "https://img.shields.io/badge/api-"${ref}"-ff69b4.svg" | base64)

PAYLOAD=$(cat << JSON
{
  "branch": "master",
  "commit_message": "New bicing-statistics-api badges",
  "actions": [
    {
      "action": "update",
      "file_path": "bicing-statistics-api/build.svg",
      "encoding": "base64",
      "content": "${BADGE_BUILD}"
    },
    {
      "action": "update",
      "file_path": "bicing-statistics-api/coverage.svg",
      "encoding": "base64",
      "content": "${BADGE_COVERAGE}"
    },
    {
      "action": "update",
      "file_path": "bicing-statistics-api/reference.svg",
      "encoding": "base64",
      "content": "${BADGE_REF}"
    }
  ]
}
JSON
)

curl --request POST \
    --header "PRIVATE-TOKEN: ${BADGE_REPOSITORY_PRIVATE_TOKEN}" \
    --header "Content-Type: application/json" \
    --data "$PAYLOAD" https://gitlab.com/api/v4/projects/10513975/repository/commits
