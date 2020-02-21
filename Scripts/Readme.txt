There are three scripts built for the purpose of this project.

They need to be used in a particular order for the best results.

1)First use folder.py to rename your directory structure in the fashion "Level-alphabet". It currently supports renaming 52 subfolders at each level, which can be easily increased by appending more characters to the test_list.

2)Then use file.py to flatten the directory structure and append a prefix to each dicom file in the fashion "PatientDetails_subfolder directory structure_filename".

You can also do this for all files by removing the if f in '.dcm'. Or change the extension accordingly.

3)Then run zip.py to zip n folders at a time and being named in the fashion zip(i).zip. You can change the value of n, and the naming pattern as per your requirements