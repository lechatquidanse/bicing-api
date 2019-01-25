#!/usr/bin/env bash

JOB_URL="https://gitlab.com/api/v4/projects/${CI_PROJECT_ID}/jobs/${CI_JOB_ID}"
JOB=$(curl  --header "PRIVATE-TOKEN: ${REPOSITORY_PRIVATE_TOKEN}" ${JOB_URL})

status= JOB | jq '.status'
coverage= JOB | jq '.coverage'
ref = JOB | jq '.pipeline.ref'

echo '--------------------------------'
echo ${status}
echo '--------------------------------'
echo '--------------------------------'
echo ${coverage}
echo '--------------------------------'
echo '--------------------------------'
echo ${ref}
echo '--------------------------------'


if [ status = 'success' ]
then
    status_color = 'green'
else
    status_color = 'red'
fi

BADGE_BUILD=$(curl "https://img.shields.io/badge/pipeline-"${status}"-"${status_color}".svg" | base64)
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
