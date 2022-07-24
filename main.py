import pymongo as mungo
from collections import OrderedDict
import time
import os
import webbrowser
import subprocess

entered_symptoms = []
relcan_entered_symptoms = []

myclient = mungo.MongoClient(
    "mongodb+srv://code:pycode123@cluster0.xko58et.mongodb.net/test")

mydb = myclient["Mungo1"]

mycol = mydb["Semptom-Hastalik"]

mycol2 = mydb["Hastalik-Kac"]

data = mycol.find()

data2 = mycol2.find()

data3 = mycol.find(projection={"_id": 0, "symptom": 1})

ld3 = list(data3)

datac = mycol.count_documents({})

datac2 = mycol2.count_documents({})

disease_dict = {}

disease_list = [data2[r].get("disease") for r in range(datac2)]

for r in range(datac2):
    qq = data2[r].get("disease")
    bqq = qq.split("\n")
    for ty in bqq:
        disease_dict[ty] = [0, 0]

print("Hi, welcome to Mungozer. Please check your browser after few seconds.\nIf PHP exe can't run or starting browser fails, try running and using main_cli.py.")

symptomarr = []

if os.path.exists("data2.txt"):
    os.remove("data2.txt")

with open("data.txt", "w") as tfile:
    tfile.write("")

    for r in range(datac):
        tdata = str(data[r].get("symptom"))
        symptomarr.append(tdata)

    symptomarr.sort()

    tfile.write('\n'.join(symptomarr))
    tfile.write("\n||1\n")
    tfile.close()

phpprocess = subprocess.Popen(
    'start /wait php\\php.exe -S localhost:8000'.split(), shell=True)

webbrowser.open("http://localhost:8000", new=1, autoraise=True)

time.sleep(2)

while(True):
    fileread1 = []

    with open('data.txt') as myfile:
        while (True):
            fileread1 = myfile.read().split("\n")
            if ("||2" in fileread1):
                myfile.close()
                break
            myfile.seek(0)

    entered_symptoms = []
    relcan_entered_symptoms = []

    relcan_entered_symptoms.extend(fileread1[fileread1.index("||1")+1:-2])

    seconds = time.time()

    entered_symptoms = list(OrderedDict.fromkeys(relcan_entered_symptoms))

    tg = []

    for i in entered_symptoms:
        hh = ld3.index({"symptom": i})
        tg = [data[hh].get("disease"), data[hh].get("point")]
        for j in range(len(tg[0])):
            disease_dict[str(tg[0][j])] = [disease_dict.get(tg[0][j])[
                0] + 1, disease_dict.get(tg[0][j])[1] + tg[1][j]]

    jj = 0
    pp = []
    np = []

    for key, value in disease_dict.items():
        val = value[1]
        ol = ""
        priority = 0
        lmt = data2[disease_list.index(key)].get("limit")
        if lmt[0] <= val:
            if val < lmt[1]:
                ol = "Medium Possibility"
                priority = 3
            elif val < lmt[2]:
                ol = "High Possibility"
                priority = 2
            elif lmt[2] <= val:
                ol = "Very Likely"
                priority = 1

            pp.append(str(key) + " " + str(val) + "/" + str(lmt[2]) + " " + ol)
            # We are adding 2 item list. [index of the item in pp list, priority of the item]
            np.append([jj, priority])
            jj += 1

    print("Calculated in", time.time() - seconds, "seconds!")

    print("\nResults are listed by probability:\n")

    def myf(vv):
        return vv[1]

    np.sort(key=myf)

    with open("data2.txt", "w") as tfile2:

        if len(np) == 0:
            print("There seems nothing that serious.")
            tfile2.write("There seems nothing that serious.")

        else:
            for ww in np:
                print(pp[ww[0]])
                tfile2.write(pp[ww[0]]+"\n")

        tfile2.close()

    time.sleep(2)

    if os.path.exists("data2.txt"):
        os.remove("data2.txt")

    with open("data.txt", "w") as tfile3:

        tfile3.write('\n'.join(symptomarr))
        tfile3.write("\n||1\n")
        tfile3.close()

    for r in range(datac2):
        qq = data2[r].get("disease")
        bqq = qq.split("\n")
        for ty in bqq:
            disease_dict[ty] = [0, 0]
