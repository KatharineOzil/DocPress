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

    if not os.path.exists('task_temp/%s.txt' % ( name)):
        if (ext == '.doc'):
            os.system('/usr/bin/wvText \'%s\' \'task_temp/%s.txt\'' % (path, name))
        elif (ext == '.docx'):
            os.system('/usr/local/bin/docx2txt.pl \'%s\' \'task_temp/%s.txt\'' % (path, name))
        elif (ext == '.pdf'):
            os.system('pdftotext \'%s\' \'task_temp/%s.txt\'' % (path, name))
    return 'task_temp/%s.%s' % (name, 'txt')

def diff_page(base_content, diff_content, range_=10):
    # return SequenceMatcher(None, base_content, diff_content).ratio()
    return float(os.popen('/usr/local/bin/diffh \'%s\' \'%s\' %d' % (base_content, diff_content, range_)).read())

#def get_files(ext):
#    return [i for i in os.listdir('./') if i.endswith(ext)]

if __name__ == '__main__':
    import itertools
    import shutil
    import glob

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
        print 'Create Temp Dir ...'
        os.mkdir('task_temp')

    file_list = []
    for ext in EXTS:
        file_list.extend(glob.glob('*%s' % ext))

    for i in file_list:
        print 'Transform: %s' % i
        transformation_format(i)

    with open('%s.txt' % sys.argv[1], 'w') as f:
        f.write('%d\n' % len(file_list))

    print 'Comparing ...'

    with open('%s.txt' % sys.argv[1], 'a') as f:
        for i in itertools.combinations(file_list, 2):
            a, b = i
            origin_path = transformation_format(a)
            compare_path = transformation_format(b)
            result = diff_page(origin_path, compare_path, range_) * 100
            print a,' ', b, ' ',
            print '%.2f%%' % result
            f.write('%s\t%s\t%.4f\n' % (a.split('_')[1], b.split('_')[1], 1-result/100.0))

    print 'Delete Temp Dir ...'
    shutil.rmtree('task_temp')
