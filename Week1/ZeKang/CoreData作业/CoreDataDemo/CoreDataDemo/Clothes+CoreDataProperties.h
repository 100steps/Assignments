//
//  Clothes+CoreDataProperties.h
//  CoreDataDemo
//
//  Created by 陈泽康 on 2016/10/29.
//  Copyright © 2016年 zekang. All rights reserved.
//
//  Choose "Create NSManagedObject Subclass…" from the Core Data editor menu
//  to delete and recreate this implementation file for your updated model.
//

#import "Clothes.h"
#import <CoreData/CoreData.h>
NS_ASSUME_NONNULL_BEGIN

@interface Clothes (CoreDataProperties)

@property (nullable, nonatomic, retain) NSString *name;
@property (nullable, nonatomic, retain) NSNumber *price;

@end

NS_ASSUME_NONNULL_END
