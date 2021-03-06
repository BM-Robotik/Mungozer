import pymongo as mungo
from progress.bar import Bar
from collections import OrderedDict
import time

entered_symptoms = []
relcan_entered_symptoms = []

myclient = mungo.MongoClient("mongodb+srv://code:pycode123@cluster0.xko58et.mongodb.net/test")

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
    qq=data2[r].get("disease")
    bqq=qq.split("\n")
    for ty in bqq:
        disease_dict[ty] = [0, 0]

# def find_symptom_disease_data(symptom):
#       global data
#       for hh in range(datac):
#           if data[hh].get("symptom") == symptom:
#               return [data[hh].get("disease"), data[hh].get("point")]


print("Hi, welcome to Mungozer. Please select your symptoms from the list below (Separate with spaces, enter the numbers):")
for r in range(datac):
    print(str(r + 1) + ". " + str(data[r].get("symptom")))

es = input("Selection: ")

print("Calculating, please wait...")

seconds = time.time()

ess = es.split(" ")
for ss in ess:
    try:
        if 0 < int(ss) <= datac:
            relcan_entered_symptoms.append(data[int(ss)-1].get("symptom"))
    finally:
        pass

entered_symptoms = list(OrderedDict.fromkeys(relcan_entered_symptoms))

# print(entered_symptoms)

bar1 = Bar('Processing Server Data', max=len(entered_symptoms), force_tty=True)

tg = []

for i in entered_symptoms:
    hh = ld3.index({"symptom": i})
    tg = [data[hh].get("disease"), data[hh].get("point")]
    for j in range(len(tg[0])):
        disease_dict[str(tg[0][j])] = [disease_dict.get(tg[0][j])[0] + 1, disease_dict.get(tg[0][j])[1] + tg[1][j]]
    bar1.next()
bar1.finish()

jj = 0
pp = []
np = []

bar2 = Bar('Processing Results', max=len(disease_dict.items()), force_tty=True)
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
        np.append([jj, priority])  # We are adding 2 item list. [index of the item in pp list, priority of the item]
        # print(str(key) + " " + str(value) + "/" + str(data2[disease_list.index(key)].get("count")) + " " + ol)
        jj += 1

    bar2.next()
bar2.finish()

print("Calculated in", time.time() - seconds, "seconds!")

print("\nResults are listed by probability:\n")


def myf(vv):
    return vv[1]


np.sort(key=myf)

if len(np) == 0:
    print("There seems nothing that serious.")

else:
    for ww in np:
        print(pp[ww[0]])

