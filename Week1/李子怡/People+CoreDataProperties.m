//
//  People+CoreDataProperties.m
//  通讯录
//
//  Created by apple on 2016/10/28.
//  Copyright © 2016年 modouhe. All rights reserved.
//

#import "People+CoreDataProperties.h"

@implementation People (CoreDataProperties)

+ (NSFetchRequest<People *> *)fetchRequest {
	return [[NSFetchRequest alloc] initWithEntityName:@"People"];
}

@dynamic name;
@dynamic phone;
@dynamic qq;
@dynamic image;
@dynamic firstN;
@end
