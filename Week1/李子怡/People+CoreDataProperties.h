//
//  People+CoreDataProperties.h
//  通讯录
//
//  Created by apple on 2016/10/28.
//  Copyright © 2016年 modouhe. All rights reserved.
//

#import "People+CoreDataClass.h"


NS_ASSUME_NONNULL_BEGIN

@interface People (CoreDataProperties)

+ (NSFetchRequest<People *> *)fetchRequest;

@property (nullable, nonatomic, copy) NSString *name;
@property (nullable, nonatomic, copy) NSString *phone;
@property (nullable, nonatomic, copy) NSString *qq;
@property (nullable, nonatomic, copy) NSData * image;
@property (nullable, nonatomic, copy) NSString *firstN;
@end

NS_ASSUME_NONNULL_END
