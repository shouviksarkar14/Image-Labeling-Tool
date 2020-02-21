import os
import platform
directory = "APPANRAJ-27-M"

for dirpath,_,filenames in os.walk(directory):
    for f in filenames:
        if '.dcm' in f:
            stringa = os.path.split(os.path.abspath(os.path.join(dirpath, f))) #splits the directory name and the file name
            strings = os.path.relpath(stringa[0],directory) #Contains relative path
            stringolinux = strings.replace('/','_')#contains path to be appended to our dicom file in linux/UNIX filesystems
            stringowindows = strings.replace('\\', '_') #contains path to be appended to our dicom file in Windows filesystems
            if (platform.system()=='Windows'):
            	filename = stringowindows + stringa[1]
            elif (platform.system()=='Linux'):
            	filename = stringolinux + stringa[1] 
            os.rename(os.path.join(dirpath, f),os.path.join(dirpath, filename))