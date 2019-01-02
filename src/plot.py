from collections import Counter

'''
def count_elements(seq) -> dict:
    """Tally elements from `seq`."""
    hist = {}
    for i in seq:
        hist[i] = hist.get(i, 0) + 1
    return hist
'''

def ascii_histogram(seq) -> None:
    """A horizontal frequency-table/histogram plot."""
    #counted = count_elements(seq)
    counted = Counter(seq)
    for k in sorted(counted):
        print('{0:5d} {1}'.format(k, '+' * counted[k]))



# Need not be sorted, necessarily
#a = (0, 1, 1, 1, 2, 3, 7, 7, 23)

#print(Counter(a))
#ascii_histogram(a)


import pandas as pd
import numpy as np
import matplotlib.pyplot as plt

df = pd.read_csv("output/age.csv")

df = df[df['age'] < 200]

print(df)



ascii_histogram(df[df.columns[1]])

print(df.describe())



#print(df.groupby(df.columns[1]).agg(np.size))

#ascii_histogram(df.groupby(df.columns[1]).agg(np.size))


#f = df.groupby('age').agg({'freq': np.size})
f = df.groupby('age').size().reset_index(name='freq')


print(f)

#print(f.plot)
#f.plot.hist()


#f.hist()
f.plot(x='age', y='freq')

plt.savefig('output/plot_age_freq')

plt.show()

