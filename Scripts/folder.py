import os
import string
dir = "CS Work" #Change the directory here for renaming, the rest will be done automatically


def reversewalk(path):
    dirlist = {}
    for dirName, subdirList, fileList in os.walk(path, topdown=False):
        depth = dirName.count(os.path.sep)
        dirlist[os.path.abspath(dirName)] = (depth, dirName, subdirList)
    return sorted(dirlist.items(), key = lambda x: x[1], reverse = True) #Set reverse as false for a descending order script

x = (reversewalk(dir))
test_list = list(string.ascii_lowercase + string.ascii_uppercase) #This contains 52 characters. if the no. of subfolders per level is>52, you'll need to add sufficient characters to test_list, else the script will fail.
i = 0
a = 0
for item in x:
    level = x[i][1][0]
    if(x[i] != x[i-1]):
        a = 0
    if(x[i][1][2]):
        b = len(x[i][1][2])-1
        while(b >= 0):
            if(level != 0):
            	 os.rename(x[i][0]+'/'+x[i][1][2][b],x[i][0]+'/'+"{}-{}".format(level, test_list[a]))
            b -= 1
            a += 1
    i += 1