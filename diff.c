#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define MAX 500

#define HASH_TABLE_MAX_SIZE 20000

typedef struct HashNode hash;
struct HashNode
{
    char* sKey;
    int nValue;
    hash *pNext;
};


void hash_table_init(hash **hashNode, int *hash_table_size)
{
    *hash_table_size = 0;
    memset(hashNode, 0, sizeof(hash *) * HASH_TABLE_MAX_SIZE);
}

unsigned int hash_table_hash_str(const char* skey)
{
    const signed char *p = (const signed char*)skey;
    unsigned int h = *p;
    if(h)
    {
        for(p += 1; *p != '\0'; ++p)
            h = (h << 5) - h + *p;
    }
    return h;
}

//insert key-value into hash table
void hash_table_insert(const char* skey, int nvalue, hash **hashTable, int *hash_table_size)
{
    if(*hash_table_size >= HASH_TABLE_MAX_SIZE)
    {
        printf("out of hash table memory!\n");
        return;
    }

    unsigned int pos = hash_table_hash_str(skey) % HASH_TABLE_MAX_SIZE;

    hash* pHead = hashTable[pos];
    while(pHead)
    {
        if(strcmp(pHead->sKey, skey) == 0)
        {
            printf("%s already exists!\n", skey);
            return ;
        }
        pHead = pHead->pNext;
    }

    hash* pNewNode = (hash*)malloc(sizeof(hash));
    memset(pNewNode, 0, sizeof(hash));
    pNewNode->sKey = (char*)malloc(sizeof(char) * (strlen(skey) + 1));
    strcpy(pNewNode->sKey, skey);
    pNewNode->nValue = nvalue;

    pNewNode->pNext = hashTable[pos];
    hashTable[pos] = pNewNode;

    hash_table_size++;
}

hash* hash_table_lookup(const char* skey, hash **hashTable)
{
    unsigned int pos = hash_table_hash_str(skey) % HASH_TABLE_MAX_SIZE;
    if(hashTable[pos])
    {
        hash* pHead = hashTable[pos];
        while(pHead)
        {
            if(strcmp(skey, pHead->sKey) == 0)
                return pHead;
            pHead = pHead->pNext;
        }
    }
    return NULL;
}


void sliding_window(FILE *fp, int len, int *file_len, hash **hashNode, int *hash_table_size)
{
    char str[MAX];

    while (fgets(str, MAX, fp)) {
        int i, j;
        for (i=0; i<(MAX - len + 1); i++) {
            // $sub_string = substr($line,$i,$string_len);
            char temp[MAX];
            char *str_offset = str;
            for (j=0; j<i; j++) {
                str_offset ++;
            }
            temp[len] = '\0';
            strncpy(temp, str_offset, len);

            // $string_num1{$sub_string} += 1;
            int num = 1;

            hash* pnode = hash_table_lookup(temp, hashNode);
            if (pnode != NULL) {
                pnode->nValue += 1;
            } else {
                hash_table_insert(temp, num, hashNode, hash_table_size);
            }

            *file_len += 1;
        }

    }
}

int main(int argc, char *argv[])
{
    if (argc < 4) {
        printf("Usage: diff FILE1 FILE2 len\n");
        return 1;
    }
    FILE *fp_1;
    FILE *fp_2;
    long len;
    char *endptr;

    len = strtol(argv[3], &endptr, 10);
    if (endptr == argv[3]) {
        printf("No digists were found\n");
        return 1;
    }

    if (len <= 0 || len > MAX) {
        printf("len must greater than 0 and less than %d\n", MAX);
        return 1;
    }

    if (!(fp_1 = fopen(argv[1], "r"))) {
        printf("File %s opened failed\n", argv[1]);
        return 1;
    }

    if (!(fp_2 = fopen(argv[2], "r"))) {
        printf("File %s opened failed\n", argv[2]);
        return 1;
    }

    hash* hashTable_1[HASH_TABLE_MAX_SIZE];
    hash* hashTable_2[HASH_TABLE_MAX_SIZE];
    int hash_table_size_1, hash_table_size_2;
    int file_len1 = 0, file_len2 = 0;

    hash_table_init(hashTable_1, &hash_table_size_1);
    hash_table_init(hashTable_2, &hash_table_size_2);
    sliding_window(fp_1, len, &file_len1, hashTable_1, &hash_table_size_1);
    sliding_window(fp_2, len, &file_len2, hashTable_2, &hash_table_size_2);

    fclose(fp_1);
    fclose(fp_2);


    int comm = 0;

    int i;
    for(i = 0; i < HASH_TABLE_MAX_SIZE; ++i) {
        if(hashTable_1[i])
        {
            hash* pHead = hashTable_1[i];
            while(pHead)
            {
                hash *pNode = hash_table_lookup(pHead->sKey, hashTable_2);
                if (pNode) {
                    if (pHead->nValue < pNode->nValue) {
                        comm += pHead->nValue;
                    } else {
                        comm += pNode->nValue;
                    }
                }
                pHead = pHead->pNext;
            }
        }
    }
    float diff = 0;
    //printf("%d %d %d\n", comm, file_len1, file_len2);
    if (file_len1 < file_len2) {
        diff = (float)comm / (float)file_len1;
    } else {
        diff = (float)comm / (float)file_len2;
    }

    printf("%.4f\n", diff);
    return 0;
}
