
aflix-project

Git Workflow

* Create a new branch from master HEAD. Branch name should start with fix- or feature-, eg feature-gcp-cloud-files or fix-admin-area

* Merge this branch into dev and test on dev site

* Create merge request and assign repository owner to review and accept this merge request

* Git deployment automatically deploys master branch into the production server and dev branch into the dev server, deployment takes up 3 minutes until a new code is on it's destination server
