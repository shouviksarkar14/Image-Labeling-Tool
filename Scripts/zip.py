import os
import zipfile
directory = "media/shouvik/Backup Plus/CT Scans" #Change the directory you want it to be used in
n = 100 #Change the number of folders you want in one zip
files= os.listdir(directory) #Lists all directories/files in the directory and stores in the files list
final = [files[i*n:(i+1)*n] for i in range ((len(files)+n-1)//n)] #Divides the files list into groups of n, making it a list of lists.

def zipdir(path, ziph):
    # ziph is zipfile handle
    for root, dirs, files in os.walk(path):
        for file in files:
            ziph.write(os.path.join(root, file),
                       os.path.relpath(os.path.join(root, file),
                                       os.path.join(path, '..')))


def zipit(dir_list, zip_name):
    zipf = zipfile.ZipFile(zip_name, 'w', zipfile.ZIP_DEFLATED, allow_zip64 = True) #Set allow_zip64 to true for zip files larger than 4 gb to be created.
    for dir in dir_list:
        zipdir(dir, zipf)
    zipf.close()

for i in range(len(files)/n):
	zipit(final[i],'zip'+str(i)+'.zip') #You can change your naming pattern here
