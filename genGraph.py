import matplotlib.pyplot as plt
import os
def makePlot():
    plt.plot([1,2,3,4])
    plt.ylabel('some numbers')
    plt.savefig('d:\\xampp\\htdocs\\Gcoin\\graph.png')
def deletePlot():
    os.remove("d:\\xampp\\htdocs\\Gcoin\\graph.png")

if(os.path.exists("d:\\xampp\\htdocs\\Gcoin\\graph.png")):
    deletePlot()
    makePlot()
    print('deletePlot and make one')
else:
    makePlot()
    print('make plot')