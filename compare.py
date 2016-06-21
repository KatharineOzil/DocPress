# coding: utf-8
from difflib import SequenceMatcher
import sys
import os
import time

EXTS = ('.doc', '.docx', '.pdf')

def readfile(filename):
    with open(filename, 'r') as f:
        data = f.read()
    # replace_list = ['\t', '\n', ' ', ',', '.', '，', '。', '；']
    # for i in replace_list:
    #    data = data.replace(i, '')
    return data

def file_extension(path):
    return os.path.splitext(os.path.basename(path))

def transformation_format(path):
    name, ext = file_extension(path)
    if not ext in EXTS:
        return None
    os.putenv('PATH', '/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/sbin')
    if not os.path.exists('task_temp/%s.txt' % ( name)):
        if (ext == '.doc'):
            os.system('/usr/bin/wvText \'%s\' \'task_temp/%s.txt\'' % (path, name))
        elif (ext == '.docx'):
            os.system('/usr/local/bin/docx2txt.pl \'%s\' \'task_temp/%s.txt\'' % (path, name))
        elif (ext == '.pdf'):
            os.system('pdftotext \'%s\' \'task_temp/%s.txt\'' % (path, name))
    file_name = 'task_temp/%s.%s' % (name, 'txt')
    with open(file_name, 'r') as f:
        content = f.read()
    data = content.replace(' ', '').replace('\n', '').replace('\t', '')
    with open(file_name, 'wb') as f:
        f.write(data)
    return file_name

def diff_page(base_content, diff_content, range_=10):
    # return SequenceMatcher(None, base_content, diff_content).ratio()
    return float(os.popen('/usr/local/bin/diffh \'%s\' \'%s\' %d' % (base_content, diff_content, range_)).read())


if __name__ == '__main__':
    import itertools
    import shutil
    import glob
    import csv

    if len(sys.argv) < 2:
        print 'Missing arguments, Usage: compare.py <dir> <range>'
        exit(1)

    range_ = sys.argv[2]
    if not range_.isdigit():
        range_ = 10
    else:
        range_ = int(range_)

    if not os.path.exists('upload/' + sys.argv[1]):
        print '暂时没有人上交作业'
        exit(1)

    os.chdir('upload/' + sys.argv[1])

    if not os.path.exists('task_temp'):
        # print 'Create Temp Dir ...'
        os.mkdir('task_temp')

    file_list = []
    for ext in EXTS:
        file_list.extend(glob.glob('*%s' % ext))

    for i in file_list:
        # print 'Transform: %s' % i
        transformation_format(i)

    with open('%s.txt' % sys.argv[1], 'w') as f:
        f.write('%d\n' % len(file_list))

    # print 'Comparing ...'

    csv_row = []
    with open('%s.txt' % sys.argv[1], 'a') as f:
        for i in itertools.combinations(file_list, 2):
            a, b = i
            origin_path = transformation_format(a)
            compare_path = transformation_format(b)
            result = diff_page(origin_path, compare_path, range_) * 100
            csv_row.append((a.decode('utf-8').encode('gbk'), b.decode('utf-8').encode('gbk'), '%.2f' % result))
            print a,' ', b, ' ', '%.2f%%' % result
            f.write('%s\t%s\t%.4f\n' % (a.split('_')[1], b.split('_')[1], 1-result/100.0))

    csv_row.sort(key=lambda tup: float(tup[2]))
    csvfile = file('%s.csv' % sys.argv[1], 'wb')
    writer = csv.writer(csvfile)
    writer.writerow([u'作业1'.encode('gbk'), u'作业2'.encode('gbk'), u'相似度'.encode('gbk')])
    writer.writerows(csv_row)
    csvfile.close()

    # print 'Delete Temp Dir ...'
    shutil.rmtree('task_temp')
