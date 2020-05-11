pipeline {
    agent any
    
    
    stages {
     
        
		
		stage('code sniff') {
			steps {
					
					sh 'echo "phpcs service/"'
					echo 'checking starts ..'
					sh 'echo "Checking code errors.."'
		
                    sh 'phpcs -e --colors --generator=HTML service/ >> codesniffreults.html'
                    sh 'phpcs -v  --colors --report-file="report.json" service/ || true'
                    
                	echo 'checking done ..'
                	
				
					
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
			archiveArtifacts artifacts: 'codesniffreults.html', fingerprint: true
			archiveArtifacts artifacts: 'report.csv', fingerprint: true
		
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

