pipeline {
    agent any
    
    
    stages {
     
        
		
		vendor/squizlabs/php_codesniffer/bin/phpcs service/
		stage('code sniff') {
			steps {
					
					sh 'echo "<<<Validate composer.json and composer.lock>>>"'
					
                    sh ' vendor/squizlabs/php_codesniffer/bin/phpcs service/vendor/squizlabs/php_codesniffer/bin/phpcs service/
'
					
			   }
			   
			}
			
		stage('Build') {
			steps {
					
					sh 'echo "<<<Validate composer.json and composer.lock>>>"'
					
                    sh 'php composer.phar validate'
					
					sh 'echo "<<<Install dependencies>>>"'
					
                    sh 'php composer.phar install --prefer-dist --no-progress'
					
			   }
			   
			}
        
        
	stage('Test') {
            steps {
				sh 'echo "<<<Testing>>>"'

           }
        }
	stage('Deploy') {
            steps {
                timeout(time: 3, unit: 'MINUTES') {
                    retry(5) {
                        sh 'echo "<<<Deploying>>>"'
                    }
                }
            }
		}
    }
     post {
        always {
            echo 'One way or another, I have finished'
			
			archiveArtifacts artifacts: 'service/**/*.php', fingerprint: true
			archiveArtifacts artifacts: 'js/**/*.js', fingerprint: true
			archiveArtifacts artifacts: 'css/**/*.css', fingerprint: true
			archiveArtifacts artifacts: 'moderator.html', fingerprint: true
			archiveArtifacts artifacts: 'index.html', fingerprint: true
			
            deleteDir() /* clean up our workspace */
        }
        success {
            echo 'I succeeeded!'
            
			
        }
        unstable {
            echo 'I am unstable ??'
        }
        failure {
            echo 'I failed ??'
			
			
        }
        changed {
            echo 'Things were different before...'
        }
    }
}

